<template>
    <div class="wrapper">
        <div class="container">
            <div class="left">
                <div class="top">


                    <img style="height: 46px;     float: left;" :src="auth.image" alt="" />

                        <span class="dropdown search" style="float: left; margin-right: 10px;top: 13px;left: 20px" aria-hidden="true">

                          <div v-if="auth.name<11">{{ auth.name }}</div>
                           <div v-else>  {{auth.name.substring(0,11)+".."}}</div>

                        </span>


                    <a  onclick="event.preventDefault();document.getElementById('logout-form').submit();"    style="float: right; font-size: 22px; padding: 10px;" >        <i class="fa fa-sign-out"></i></a>

                    <div>
                        <form id="logout-form" action="logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" :value="csrf">
                        </form>
                    </div>



                </div>
                <ul class="people">
                    <li class="person"    @click.prevent="openChat(friend)"  v-for="friend in friends" :key="friend.id">
                        <img :src="friend.image" alt="" />
                        <span class="name"> {{friend.name}}</span>
                        <span class="time search" style="  padding: 5px; background: #00b0ff; border: 2px solid #00b0ff; color: #effbff; text-align: center;font-size: 16px" v-if="friend.session && friend.session.unreadCount > 0">{{friend.session.unreadCount}}</span>

                        <span  class="preview" style="color:#00b0ff" v-if="friend.online" >Online</span>
                        <span  class="preview" v-else>Offline</span>

                    </li>
                </ul>
            </div>



            <div v-for="friend in friends" :key="friend.id" v-if="friend.session">
                    <private-message-component
                        v-if="friend.session.open"
                        @close="close(friend)"
                        :friend="friend"
                    ></private-message-component>
                </div>


        </div>
    </div>
</template>

<script>
    import PrivateMessageComponent from "./PrivateMessageComponent";
    export default {
        data() {
            return {
                friends: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                auth: window.auth
            };
        },
        methods: {
            close(friend) {
                friend.session.open = false;
            },
            getFriends() {
                axios.post("/getFriends").then(res => {
                    this.friends = res.data.data;
                    this.friends.forEach(
                        friend => (friend.session ? this.listenForEverySession(friend) : "")
                    );
                });
            },
            openChat(friend) {
                if (friend.session) {
                    this.friends.forEach(
                        friend => (friend.session ? (friend.session.open = false) : "")
                    );
                    friend.session.open = true;
                    friend.session.unreadCount = 0;
                } else {
                    this.createSession(friend);
                }
            },
            createSession(friend) {
                axios.post("/session/create", { friend_id: friend.id }).then(res => {
                    (friend.session = res.data.data), (friend.session.open = true);
                });
            },
            listenForEverySession(friend) {
                Echo.private(`Chat.${friend.session.id}`).listen(
                    "PrivateChatEvent",
                    e => (friend.session.open ? "" : friend.session.unreadCount++)
                );
            }
        },
        created() {
            this.getFriends();

            Echo.channel("Chat").listen("SessionEvent", e => {
                let friend = this.friends.find(friend => friend.id == e.session_by);
                friend.session = e.session;
                this.listenForEverySession(friend);
            });

            Echo.join(`Chat`)
                .here(users => {
                    this.friends.forEach(friend => {
                        users.forEach(user => {
                            if (user.id == friend.id) {
                                friend.online = true;
                            }
                        });
                    });
                })
                .joining(user => {
                    this.friends.forEach(
                        friend => (user.id == friend.id ? (friend.online = true) : "")
                    );
                })
                .leaving(user => {
                    this.friends.forEach(
                        friend => (user.id == friend.id ? (friend.online = false) : "")
                    );
                });
        },
        components: { PrivateMessageComponent }
    };
</script>

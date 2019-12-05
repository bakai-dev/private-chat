<template>
    <div class="right">
        <div class="top">
            <span>To: <span class="name">
                <span :class="{'text-danger':session.block}">
                {{friend.name}} <span v-if="isTyping">is Typing</span>
                <span v-if="session.block" class="text-danger">(blocked)</span>
            </span>
            </span>
            </span>
            <a href="" @click.prevent="close">
                <i class="fa fa-times" style="float: right; color: #6b6b6b; margin-left: 10px" aria-hidden="true"></i>
            </a>
            <div style="float: right; margin-right: 10px"  class="dropdown">
                <i class="fa fa-ellipsis-v" style=" color: #6b6b6b" aria-hidden="true"></i>
                <div class="dropdown-content">
                    <a   href="#" v-if="session.block && can" @click.prevent="unblock">UnBlock</a>
                    <a   href="#" @click.prevent="block" v-if="!session.block">Block</a>

                    <a   href="#" @click.prevent="clear"> Clear Chat</a>
                </div>
            </div>

        </div>

        <div class="chat" style="max-height: 460px; overflow-y: scroll;" v-chat-scroll  >


            <div   class="card-text" v-chat-scroll>
                <p  :class="{'bubble you':chat.type === 0,'bubble me':chat.type === 1}" v-for="chat in chats" :key="chat.id">
                    {{chat.message}}
                    <br>
                    <span style="font-size:10px">send {{chat.send_at}}</span>

                    <br>
                    <i v-if="chat.read_at!=null" class="fa fa-check" style=" color: #fff9fe" aria-hidden="true">
                        <span style="font-size:10px">read {{chat.read_at}}</span>
                    </i>

                </p>
            </div>

   <!--             <div class="card-text"   v-for="chat in chats" :key="chat.id">

                    <div class="bubble you" v-if="chat.type === 1">
                        {{chat.message}}
                        <i v-if="chat.read_at!=null" class="fa fa-check" style=" color: #fff9fe" aria-hidden="true">
                        </i>

                        <span v-if="chat.sent_at" style="font-size:9px">{{chat.read_at}}</span>
                    </div>
                    <div class="bubble me" v-else>
                        {{chat.message}}
                        <i v-if="chat.read_at!=null" class="fa fa-check" style=" color: #00b0ff" aria-hidden="true">
                        </i>
                        <span v-if="chat.read_at" style="font-size:9px">{{chat.read_at}}</span>

                    </div>
                </div>-->
        </div>
        <div class="write">
            <form   class="card-footer"  @submit.prevent="send">
            <a  class="write-link attach"></a>
            <input type="text" placeholder="Write your message here"
                   :disabled="session.block"
                   v-model="message" />
            <a  type="submit" style="cursor: pointer" @click.prevent="send" class="write-link send"></a>
            </form>
        </div>
    </div>
</template>



<script>
    export default {
        props: ['friend'],
        data() {
            return {
                chats: [],
                message: null,
                isTyping: false
            }
        },
        watch: {
            message(value) {
                if (value) {
                    Echo.private(`Chat.${this.friend.session.id}`).whisper("typing", {
                        name: auth.name
                    });
                }
            }
        },
        computed: {
            session() {
                return this.friend.session;
            },
            can() {
                return this.session.blocked_by == auth.id;
            }
        },

        created() {
            this.read();

            this.getAllMessages();



            Echo.private(`Chat.${this.friend.session.id}`).listen(
                "PrivateChatEvent",
                e => {
                    this.friend.session.open ? this.read() : "";
                    this.chats.push({ message: e.content, type: 1, send_at: "Just Now" });
                }
            );


            Echo.private(`Chat.${this.friend.session.id}`).listen("MsgReadEvent", e =>
                this.chats.forEach(
                    chat => (chat.id == e.chat.id ? (chat.read_at = e.chat.read_at) : "")
                )
            );


            Echo.private(`Chat.${this.friend.session.id}`).listen(
                "BlockEvent",
                e => (this.session.block = e.blocked)
            );


            Echo.private(`Chat.${this.friend.session.id}`).listenForWhisper(
                "typing",
                e => {
                    this.isTyping = true;
                    setTimeout(() => {
                        this.isTyping = false;
                    }, 2000);
                }
            );
        },

        methods: {
            getAllMessages() {
                axios
                    .post(`/session/${this.friend.session.id}/chats`)
                    .then(res => (this.chats = res.data.data));
            },
            send() {
                if (this.message) {
                    this.pushToChats(this.message);
                    axios
                        .post(`/send/${this.friend.session.id}`, {
                            message: this.message,
                            to_user: this.friend.id
                        })
                        .then(res => (this.chats[this.chats.length - 1].id = res.data));
                    this.message = null;
                }
            },
            pushToChats(message) {
                this.chats.push({
                    message: message,
                    type: 0,
                    read_at: null,
                    send_at: "Just now"
                });

            },
            close() {
                this.$emit('close');
            },
            clear() {
                axios.post(`session/${this.friend.session.id}/clear`).then(res => {
                    this.chats = [];
                })
            },
            block() {
                this.session.block = true;
                axios
                    .post(`/session/${this.friend.session.id}/block`)
                    .then(res => (this.session.blocked_by = auth.id));
            },
            unblock() {
                this.session.block = false;
                axios.post(`session/${this.friend.session.id}/unblock`).then(
                    res => {
                        this.session.blocked_by = null;
                    }
                );
            },

            read() {
                axios.post(`/session/${this.friend.session.id}/read`);
            }

        },

    };
</script>

<style>

    .text-danger{
     color: red !important;
    }
    .card-body {
        overflow-y: scroll;
    }
    .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        margin-top: -20px;
        margin-left: -150px;
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #f1f1f1}

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>

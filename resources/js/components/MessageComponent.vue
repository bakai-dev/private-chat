<template>
    <div class="card chat-box">
        <div class="card-header">
            <b :class="{'text-danger':session_block}">
                {{friend.name}}
                <span v-if="session_block">(blocked)</span>
            </b>
            <a href="" @click.prevent="close">
                <i class="fa fa-times float-right" aria-hidden="true"></i>
            </a>

            <div class="dropdown show float-right">
                <a href="#"   data-toggle="dropdown"   aria-expanded="false">
                    <i class="fa fa-ellipsis-v float-right mr-4"></i>
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" v-if="session_block" @click.prevent="UnBlock">UnBlock</a>
                    <a class="dropdown-item" href="#" v-else @click.prevent="block">Block</a>
                    <a class="dropdown-item" href="#" @click.prevent="clear">Clear chat</a>
                 </div>
            </div>

        </div>
        <div class="card-body" v-chat-scroll>
            <p class="card-text" :class="{'text-right':chat.type == 0,'text-success':chat.read_at!=null}" v-for="chat in chats" :key="chat.id">
                {{chat.message}}
                <br>
                <span style="font-size:9px">{{chat.read_at}}</span>
            </p>
        </div>
        <form   class="card-footer" @submit.prevent="send">
            <div class="form-group">
                <input type="text"  class="form-control" placeholder="Write your message here"
                :disabled="session_block"
                v-model="message"
                >
            </div>
            <button type="submit" class="btn btn-info">Send</button>
        </form>
    </div>

</template>



<script>
    export default {
        props: ['friend'],
        data() {
            return {
                chats: [],
                message: null,
                session_block: false
            }
        },
        created() {
            this.getAllMessages();

            this.read();

            Echo.private(`Chat.${this.friend.session.id}`).listen(
                "PrivateChatEvent",
                e => {
                    this.friend.session.open ? this.read() : "";
                    this.chats.push({ message: e.content, type: 1, sent_at: "Just Now" });
                }
            );
            Echo.private(`Chat.${this.friend.session.id}`).listen("MsgReadEvent", e =>
                this.chats.forEach(
                    chat => (chat.id == e.chat.id ? (chat.read_at = e.chat.read_at) : "")
                )
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
                    axios.post(`/send/${this.friend.session.id}`, {
                        message: this.message,
                        to_user: this.friend.id
                    }).then(
                        res => {
                            this.chats[this.chats.length -1].id = res.data
                        }
                    );
                    this.message = null;
                   // this.read()
                }
            },

            pushToChats(message) {
                this.chats.push({ message: message, type: 1, read_at: null, sent_at: "Just Now" });
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
                this.session_block = true;
            },
            UnBlock() {
                this.session_block = false;
            },

            read() {
                axios.post(`/session/${this.friend.session.id}/read`);
            }

        },

    };
</script>

<style>
    .chat-box {
        height: 400px;
    }

    .card-body {
        overflow-y: scroll;
    }
</style>

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
           <p class="card-text" :class="{'text-right': chat.type == 0 }" v-for="chat in chats" :key="chat.message">
               {{chat.message}}
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
                    });
                    this.message = null;
                }
            },

            pushToChats(message) {
                this.chats.push({ message: message, type: 0, sent_at: "Just Now" });
            },
            close() {
                this.$emit('close');
            },
            clear() {
                this.chats = [];
            },
            block() {
                this.session_block = true;
            },
            UnBlock() {
                this.session_block = false;
            },

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

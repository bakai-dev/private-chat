<template>
    <div class="card chat-box">
        <div class="card-header">
            Chats
            <a href="" @click.prevent="close">
                <i class="fa fa-times float-right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="card-body" v-chat-scroll>
           <p class="card-text" v-for="chat in chats" :key="chat.message">
               {{chat.message}}
           </p>
        </div>
        <form class="card-footer" @submit="send">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Write your message here">
            </div>
        </form>
    </div>

</template>



<script>
    export default {
        data() {
            return {
                chats: [],
            }
        },
        methods: {
            send() {
                console.log('awd')
            },
            close() {
                this.$emit('close');
            }
        },
        created() {
            this.chats.push({message: 'Hello'},
                {message: 'How are you1?'},
                {message: 'How are you2?'},
                {message: 'How are you3?'},
                {message: 'How are you4?'},
                {message: 'How are you5?'},
                {message: 'How are you6?'},
           )
        }
    }
</script>

<style>
    .chat-box {
        height: 400px;
    }

    .card-body {
        overflow-y: scroll;
    }
</style>

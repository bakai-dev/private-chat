<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Private Chat App
                    </div>
                        <ul class="list-group">
                            <a href="" @click.prevent="openChat(friend)"  v-for="friend in friends" :key="friend.id">
                                <li class="list-group-item">{{friend.name}}</li>
                            </a>
                        </ul>
                </div>
            </div>
            <div class="col-md-9">
                <span v-for="friend in friends" :key="friend.id">
                    <message-component
                        v-if="friend.session.open"
                        @close="close(friend)"
                        :friend="friend"
                    ></message-component>
                </span>

            </div>
        </div>
    </div>
</template>

<script>
    import MessageComponent from './MessageComponent'

    export default {
        data() {
            return {
                friends: []
            }
        },
        components: {
         MessageComponent
        },
        created() {

            this.getFriends();

            this.$on('close', () => {
                this.close();
            })
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            close(friend) {
                friend.session.open = false;
            },
            getFriends() {
                axios.post('/getFriend').then(res => this.friends = res.data.data);
            },
            openChat(friend) {
                this.friends.forEach(friend => {
                    friend.session.open = false;
                });
                friend.session.open = true;
            }
        }
    }
</script>

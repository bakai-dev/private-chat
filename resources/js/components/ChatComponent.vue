<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Private Chat App
                    </div>
                        <ul class="list-group">
                            <li class="list-group-item">Cras justo odio</li>
                        </ul>
                </div>
            </div>
            <div class="col-md-9">
                <message-component
                    v-if="open"
                    @close="close"
                ></message-component>
            </div>
        </div>
    </div>
</template>

<script>
    import MessageComponent from './MessageComponent'

    export default {
        data() {
            return {
                open: true
            }
        },
        components: {
         MessageComponent
        },
        created() {
            this.$on('close', () => {
                this.close();
            })
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            close() {
                this.open = false;
            }
        }
    }
</script>

# Laravel-Vue Chat App

> Private (one to one) realtime Chat App with Laravel 6.2 and Vue.

###  [Demo](http://laravel-vue-chat.herokuapp.com) 
>  http://laravel-vue-chat.herokuapp.com`


<p align="center">
<img src="https://i.imgur.com/Iisu5rg.png">
</p>
<p align="center">
<img src="https://i.imgur.com/Pp0z5lq.png">
</p>

## Features

- Who is online
- Delete message history
- Block/Unblock user
- Realtime update chat
- User typing
- User message read time
- User message sending time

## Installation

- `git clone composer https://github.com/BakayDev/private-chat.git`
- `cd private-chat && composer i && cp .env.example .env `
- Edit `.env` and set your database connection details
- Edit `.env` and set your pusher connection key `https://dashboard.pusher.com/apps/yourId/keys`)
- (When installed via git clone or download and make .env, run `php artisan key:generate` 
- `php artisan migrate:fresh --seed `
- `php artisan serve` open `http://127.0.0.1:8000`
- You can login - email :`test@gmail.com` password :`test@gmail.com`

## Usage

#### Development
resources/js/components/PrivateChatComponent.vue
resources/js/components/PrivateMessageComponent.vue

#### serve with hot reloading
npm run watch


## Pusher

Pusher `https://pusher.com/`  empowers developers with APIs to create collaboration & communication features in their web and mobile apps. 

Edit `.env` and set `PUSHER_APP_ID` `PUSHER_APP_KEY`  `PUSHER_APP_SECRET`  `PUSHER_APP_CLUSTER` 



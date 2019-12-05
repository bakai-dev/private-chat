# Laravel-Vue Chat App

> Private (one to one) realtime Chat App with Laravel 6.2 and Vue.

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
- Edit `.env` and set your database connection details
- Edit `.env` and set your pusher connection key `https://dashboard.pusher.com/apps/yourId/keys`)
- (When installed via git clone or download, run `php artisan key:generate` 
- `php artisan migrate`
- `php artisan serve` open `http://127.0.0.1:8000`

## Usage

#### Development

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```


## Pusher

Pusher `https://pusher.com/`  empowers developers with APIs to create collaboration & communication features in their web and mobile apps. 

Edit `.env` and set `PUSHER_APP_ID` `PUSHER_APP_KEY`  `PUSHER_APP_SECRET`  `PUSHER_APP_CLUSTER` 



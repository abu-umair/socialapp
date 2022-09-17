/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// vue scroll
// import VueChatScroll from 'vue-chat-scroll';
// Vue.use(VueChatScroll);
// new Vue(...);

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('message', require('./components/message.vue').default);

import Vue from 'vue'

// const app = new Vue({
//     el: '#app',
//     data:{
//         // message:'',
//         // chat:{
//         //     message:[],
//         //     user:[],
//         //     color:[]
//         // }

//         // yg baru
//         id: document.querySelector('meta[name="user_id"]').content,
//         notif: 0,
//         // id: document.getElementById('user_id').value,
//         search: '',
//         messages: [],
//         users: [],
//         form: {
//             to_id: '',
//             content: ''
//         },
//         isActive: null
//     },
//     methods:{
//         // send(){
//         //     if (this.message.length != 0) {
                
//         //         // console.log(this.message.length);
//         //         this.chat.message.push(this.message);
//         //         this.chat.color.push('success');
//         //         this.chat.user.push('you');
//         //         // this.message = ''
//         //         axios.post('/admin/message/send', {
//         //             message : this.message
//         //           })
//         //           .then(response => {
//         //             console.log(response);
//         //             this.message = ''
//         //           })
//         //           .catch(error => {
//         //             console.log(error);
//         //           });
//         //     }
//         // },
//         // yang baru
//         // mengeluarkan semua pengguna
//         fetchUsers() {
//             let q = _.isEmpty(this.search) ? 'all' : this.search
            
//             axios.get('/admin/user/' + q).then(({ data }) => {
//                 this.users = data
//             })
//         },
//         // mengeluarkan semua messages dari user yang dipilih
//         fetchMessages(id) {
//             this.form.to_id = id
//             axios.get('/admin/user-message/' + id).then(({ data }) => {
//                 this.messages = data
//                 this.isActive = this.users.findIndex((s) => s.id === id)
//                 this.users[this.isActive].count = 0
//                 this.notif--
//             })
//         },
//         // mengirim pesan yang dikirim
//         sendMessage() {
//             axios.post('/admin/user-message', this.form).then(({ data }) => {
//                 this.pushMessage(data, data.to_id)
//                 this.form.content = ''
//                 this.search = ''
//             })
//         },
//         // fungsi untuk push laravel echo dan pusher
//         fetchPusher() {
//             Echo.channel('user-message.' + this.id)
//                 .listen('MessageEvent', (e) => {
//                     this.pushMessage(e, e.from_id, 'push')
//                 })
//         },
//         // semua akan di eksekusi disini
//         pushMessage(data, user_id, action = '') {
//             let index = this.users.findIndex((s) => s.id === user_id)

//             if (index != -1 && action == 'push') {
//                 this.users.splice(index, 1)
//             }

//             /**
//              * if untuk pesan submit
//              */
//             if (action == '') {
//                 this.users[index].content = data.content
//                 this.users[index].to_id = data.to_id

//                 let user = this.users[index]

//                 this.users.splice(index, 1)
//                 this.users.unshift(user)
//             }

//             /**
//              * else untuk pesan dari laravel echo
//              */
//             else {
//                 this.users.unshift(data)
//             }

//             /**
//              * Jika dia melihat pesan user
//              */
//             if (this.form.to_id != '') {
//                 index = this.users.findIndex((s) => s.id === this.form.to_id)

//                 this.users[index].count = 0
//                 this.isActive = index

//                 if (this.form.to_id == user_id) {

//                     this.messages.push({
//                         avatar: data.avatar,
//                         content: data.content,
//                         created_at: data.created_at,
//                         from_id: data.from_id,
//                     })

//                     axios.get('/admin/user-message/' + user_id + '/read')
    
//                 }

//             }
//         },
//         // agar scroll ke arah pesan yang baru
//         scrollToEnd: function () {
//             let container = this.$el.querySelector("#card-message-scroll");
//             container.scrollTop = container.scrollHeight;
//         }
//     },
//     watch: {
//         search: _.debounce( function() {
//             this.fetchUsers()
//         }, 500),
//         users: _.debounce( function() {
//             this.notif = 0
//             this.users.filter(e => {
//                 if (e.count) {
//                     this.notif++
//                 }
//             })
//         }),
//         messages: _.debounce( function() {
//             this.scrollToEnd()
//         }, 10),
//     },
//     mounted(){
//         // Echo.private('chat')
//         //     .listen('ChatEvent', (e) => {
//         //         this.chat.message.push(e.message);
//         //         this.chat.user.push(e.user); //disend ke chat.blade
//         //         this.chat.color.push('warning');
//         //         // console.log(e);
//         //     });
//         // yg baru
//         this.fetchUsers()
//         this.fetchPusher()
//     }
// });

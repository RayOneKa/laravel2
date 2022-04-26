<template>
    <div v-if="loading" class="spinner-border text-info" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <div v-else>

        <template v-if='errors'>
            <div class='alert alert-danger'>
                <div v-for='(error, idx) in errors' :key='idx' class='errors'>
                    <p v-for='(e, i) in error' :key='i'> {{e}} </p>                                        
                </div> 
            </div>
        </template>

        <div class="mb-3">
            <label class="form-label">Изображение</label>
            <image class="user-picture mb-2" :src="user.picture"/>
            <input type="file" name="picture" class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input v-model='user.email' type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input v-model='user.name' class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Текущий пароль</label>
            <input v-model='current_password' type="password" autocomplete="off" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Новый пароль</label>
            <input v-model='password' type="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Повторите новый пароль</label>
            <input v-model='password_confirmation' type="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Список адресов</label>
            <div v-for='address in user.addresses' :key="address.id">
                <label :for="`main_address${address.id}`">{{address.address}}</label>
                <input :checked='address.main' :id="`main_address${address.id}`" type="radio">
            </div>
            <span v-if='!user.addresses'>
                Адресов пока нет.
            </span>
        </div>
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input v-model="new_address" class="form-control">
        </div>
        <button @click='save' class="btn btn-primary">Сохранить</button>
    </div>
</template>

<script>
export default {
    data () {
        return {
            loading: true,
            user: null,
            new_address: null,
            password: null,
            current_password: null,
            password_confirmation: null,
            errors: null
        }
    },
    methods: {
        save () {
            this.errors = null
            const params = {
                name: this.user.name,
                email: this.user.email,
                userId: this.user.id
            }
            axios.post('/api/profile/save', params)
                .then(() => {
                    alert('SAVED!')
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        }
    },
    mounted () {
        axios.get('/api/user')
            .then((response) => {
                this.user = response.data.user
                this.loading = false
            })
    }
}
</script>

<style scoped>
    .user-picture {
        width: 100px;
        border-radius: 100px;
        display: block;
    }

    .main-address {
        font-weight: bold;
    }

    .errors {
        padding: 10px 18px 0px;
    }
</style>
<template>
    <div>
        Example component
        <br>
        {{ name }}
        <br>
        <button v-on:click="counterPlus" class="btn btn-info">Click {{counter}}</button>

        <span v-if="counter < 10">Значение counter меньше 10</span>
        <span v-else-if="counter < 15">Значение counter меньше 15</span>
        <span v-else>Значение counter больше или равно 15</span>
        <span v-show="counter < 10">Значение counter меньше 10</span>

        <br>
        <button @click="showPicture = !showPicture" class="btn btn-success">Переключатель</button>
        <br>
        <img v-if="showPicture" style="width: 300px;" src="https://images.unsplash.com/photo-1534796636912-3b95b3ab5986?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8M3x8fGVufDB8fHx8&w=1000&q=80">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Категория</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in categories" :key="category.id">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        <a :href="`/category/${category.id}`">
                            {{ category.name }} ({{category.id}})
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <button @click="addCategory" class="btn btn-primary">Добавить категорию</button>

        <a href="/category/7">LINK!</a>

        {{ fullName }}
        <br>
        {{ fullName }}

        <br>

        <input v-model="inputText" @input="listenInput" class="form-control">

        <input v-model='name' class="form-control">

        <br>
        <input v-model="text" class="form-control">
        <br>
        {{ reversedText }}
        <br>
        {{ reverseText() }}

        <select v-model='selected' class="form-control mb-5">
            <option :value='null' selected disabled>-- Выберите значение --</option>
            <option v-for="(option, idx) in options" :value="option" :key='idx'>
                {{ option }}
            </option>
        </select>

        <button :disabled="!selected" class="btn mt-5" :class="buttonClass">Сохранить</button>
        <br>

        <button @click='getData' class="btn btn-info">Получить данные</button>

        <table class="table table-bordered">
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                </tr>
                <tr v-if="!users.length">
                    <td class="text-center" colspan="3">
                        <em>
                            Данные пока не получены
                        </em>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                inputText: '',
                text: '',
                name: 'Rail',
                lastName: 'Mingaliev',
                counter: 0,
                users: [],
                selected: null,
                showPicture: true,
                options: [1, 2, 3],
                categories: [
                    {
                        id: 7,
                        name: 'Видеокарты'
                    },
                    {
                        id: 8,
                        name: 'Процессоры'
                    },
                    {
                        id: 12,
                        name: 'Жесткие диски'
                    },
                ]
            }
        },
        computed: {
            buttonClass () {
                return this.selected ? 'btn-success' : 'btn-primary'
            },
            fullName () {
                return this.name + ' ' + this.lastName
            },
            reversedText () {
                return this.text.split('').reverse().join('')
            }
        },
        watch: {
            selected: function (newValue, oldValue) {
                console.log(`новое значение: ${newValue}, старое значение: ${oldValue}`)
            }
        },
        methods: {
            getData () {
                const params = {
                    id: 1
                }
                axios.post('/api/test', params)
                    .then(response => {
                        this.users = response.data
                    })
            },
            reverseText () {
                return this.text.split('').reverse().join('')
            },
            listenInput () {
                console.log(this.inputText)
            },
            addCategory () {
                this.categories.push({
                    id: 4,
                    name: 'Оперативная память'
                })
            },
            counterPlus () {
                this.counter += 1
            }
        },
        mounted() {
            console.log('Example component mounted.')
        }
    }
</script>

<style scoped>

</style>
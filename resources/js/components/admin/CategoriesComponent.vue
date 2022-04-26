<template>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Описание</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for='category in categories' :key='category.id'>
                    <td>{{category.name}}</td>
                    <td>{{category.description}}</td>
                </tr>
            </tbody>
        </table>      

        <template v-if='processing'>
            <button class="btn btn-success" type="button" disabled>
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                Выгружаем категории... {{this.percent}}%
            </button>

            <div class="progress mt-4">
                <div class="progress-bar" role="progressbar" :style="`width: ${percent}%`" :aria-valuenow="percent" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </template>

        <button v-else @click='exportCategories' class="btn btn-primary">Выгрузить категории</button>
        <a v-if='downloadLink' :href='`/storage/${downloadLink}`'>Скачать</a>
    </div>
</template>

<script>
export default {
    props: ['categories'],
    data () {
        return {
            processing: false,
            downloadLink: null,
            percent: 0
        }
    },
    methods: {
        exportCategories () {
            this.percent = 0
            this.downloadLink = null
            axios.post('/admin/exportCategories')
                .then(() => {
                    this.processing = true  
                })
                .catch(() => {
                    alert('Что-то пошло не так')
                })
        }
    },
    mounted () {
        Echo.channel('general')
            .listen('.exportCategoriesFinished', (data) => {
                this.processing = false
                this.downloadLink = data.message
            });

        Echo.channel('general')
            .listen('.counter', (data) => {
                this.percent = data.message
            });
    },
    destroyed () {
        Echo.channel('general')
            .stopListening('.exportCategoriesFinished')
        Echo.channel('general')
            .stopListening('.counter')
    }
}
</script>

<style>

</style>
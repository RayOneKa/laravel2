<template>
    <div>
        <div class="row">
            <category-component
                v-for='category in categories'
                :key="category.id"
                :category='category'
                @buttonClicked='buttonClicked'
            >
            </category-component>
        </div>
    </div>
</template>

<script>
    import CategoryComponent from '../components/CategoryComponent.vue'
    
    export default {
        components: {CategoryComponent},
        data () {
            return {
                categories: []
            }
        },
        methods: {
            buttonClicked (data) {
                console.log(`клик в дочернем компоненте (${data})`)
            }
        },
        mounted () {
            axios.get('/api/getCategories')
                .then((response) => {
                    this.categories = response.data
                })
        }
    }
</script>
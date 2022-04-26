import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        cartProductsQuantity: 0,
        user: null
    },
    mutations: {
        setCartProductsQuantity (state, data) {
            state.cartProductsQuantity = data
        },
        setUser(state, user) {
            state.user = user
        }
    },
    actions: {
        changecartProductsQuantity (context, data) {
            context.commit('setCartProductsQuantity', data)
        },
        setUser ({commit}, user) {
            commit('setUser', user)
        }
    }
})

export default store
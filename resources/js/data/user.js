export default {
	namespaced: true,
	state: {
		user: null
	},
	mutations: {
		setUser(state, payload) {
			state.user = payload.user;
		},
		clearUser(state) {
			state.user = null;
		}
	}
}

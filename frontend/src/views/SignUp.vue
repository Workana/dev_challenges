<template>
  <div>
    <h3>Register</h3>
    <form @submit.prevent="signUp">
      <input required type="text" v-model="username" placeholder="Enter your name"/>
      <button type="submit">Register</button>
    </form>
    <span class="error" v-show="error">{{errorMessage}}</span>
  </div>
</template>

<script>
import {mapState} from "vuex";
import auth from "../services/api/auth";
import {isError} from "../helpers/isError";
import authStorage from "../services/localStorage/authStorage";
import router from "../router/router";

export default {
  name: "SignUp",
  data() {
    return {
      username: '',
    };
  },
  computed: {
    ...mapState({
      error: state => state.error.isError,
      errorMessage: state => state.error.message
    }),
  },
  methods: {
    async signUp(){
      await this.$store.dispatch('error/clearError', null, { root: true });
      const response = await auth.signUp(this.username);

      const { status, data } = response;
      if (!isError(status)) {
        authStorage.setSession(data.payload[0]);
        authStorage.setUsername(this.username);
        await router.push('/')
      }
      else{
        await this.$store.dispatch('error/setError', `The username couldn't be registered`, { root: true });
      }
    }
  }
}
</script>

<style scoped>
form{
  margin: auto;
  max-width: 300px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

</style>

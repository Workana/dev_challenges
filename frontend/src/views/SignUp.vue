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
    signUp(){
      this.$store.dispatch('auth/signUp', this.username);
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

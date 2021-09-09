<template>
  <div>
    <h3>Register</h3>
    <form @submit.prevent="signUp">
      <input required type="text" v-model="username" placeholder="Enter your name"/>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "SignUp",
  data() {
    return {
      username: '',
    };
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

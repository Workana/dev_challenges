<template>
  <div id="container">
      <h3>Welcome {{you}}. Join a new issue</h3>
      <form @submit.prevent="joinLobby">
        <input required type="number" min="1" placeholder="Enter an issue number" v-model="issue"/>
        <button type="submit">
          Join
        </button>
      </form>
      <span class="error" v-show="error">{{errorMessage}}</span>
  </div>
</template>

<script>
import {mapState} from "vuex";
import authStorage from "../services/localStorage/authStorage";

export default {
  name: "Home",
  data() {
    return {
      issue: '',
    };
  },
  computed: {
    you() {return authStorage.getUsername()},
    ...mapState({
      error: state => state.error.isError,
      errorMessage: state => state.error.message
    }),
  },
  mounted() {
    if(!authStorage.getSession()){
      this.$router.push('/signup')
    }
  },
  methods: {
    joinLobby()
    {
      this.$store.dispatch('lobby/joinIssue', this.issue);
    }
  },
}
</script>

<style scoped>
#container{
  margin: 40px auto;
  width: 300px;
}

</style>

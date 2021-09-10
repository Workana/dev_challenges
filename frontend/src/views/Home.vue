<template>
  <div id="container">
      <h3>Join issue</h3>
      <form @submit.prevent="joinLobby">
        <input required type="number" placeholder="Enter an issue number" v-model="issue"/>
        <button type="submit">
          Join
        </button>
      </form>
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
    ...mapState({
      userIsRegistered: state => state.auth.userIsRegistered
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

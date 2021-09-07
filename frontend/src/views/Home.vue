<template>
  <div id="container">
      <h3>Join room</h3>
      <input placeholder="Enter an issue number" v-model="issue"/>
      <button @click="joinLobby">
        Join
      </button>
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
    if(authStorage.getSession() === ''){
      this.$router.push('/signup')
    }
  },
  methods: {
    joinLobby()
    {

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

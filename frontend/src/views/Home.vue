<template>
  <div id="container">
    <div>
      <button @click="createRoom">
        Create a new room
      </button>
      <button @click="joinRoom">
        Join room
      </button>
    </div>
    <div>
      <CreateNewRoom v-show="showCreateRoom"/>
      <JoinRoom v-show="showJoinRoom"/>
    </div>
  </div>
</template>

<script>
import CreateNewRoom from "../components/organisms/CreateNewRoom";
import JoinRoom from "../components/organisms/JoinRoom";

export default {
  name: "Home",
  components: {CreateNewRoom, JoinRoom},
  data() {
    return {
      showCreateRoom: false,
      showJoinRoom: false,
    };
  },
  methods: {
    createRoom()
    {
      this.showCreateRoom = true;
      this.showJoinRoom = false;
    },
    joinRoom()
    {
      this.showJoinRoom = true;
      this.showCreateRoom = false;
    }
  },
}
</script>

<style scoped>
#container{
  margin: 40px auto;
  width: 100%;
}

#container button {
  margin: 15px;
  padding: 15px;
  background-color: #e76f51;
  color: #FFFFFF;
  cursor: pointer;
}
</style>

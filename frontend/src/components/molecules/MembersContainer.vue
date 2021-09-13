<template>
  <div class="members">
    <ul id="memberList">
      <li v-for="member in this.members" :key="member.name">
        <div class="status">{{member.vote || member.status === 'Passed' ? '✅' : ''}}</div>
        <div class="name">{{member.user}} {{member.user === you ? '(you)' : null}}</div>
        <div class="vote" v-if="issueStatus === 'Voting'">-</div>
        <div class="vote"  v-if="issueStatus === 'Finished'">{{member.vote ? member.vote : 'Passed'}}</div>
      </li>
    </ul>
  </div>
</template>

<script>
import authStorage from "../../services/localStorage/authStorage";

export default {
  name: "MembersContainer",
  props: {members: Array, issueStatus: String},
  computed: {
    you() {return authStorage.getUsername()}
  },
}
</script>

<style scoped>
#memberList {
  list-style: none;
  padding: 0;
}
#memberList li {
  box-shadow: 2px 2px 2px #444;
  text-shadow: 1px 1px 1px #444;
  background: #e76f51;
  margin: 0.5em 0;
  padding: 1em;
  border-radius: 8px;
  display: flex;
  align-content: center;
}
#memberList li div {
  width: 50%;
  display: block;
  margin: auto;
}
#memberList li div.name {
  color: #FFF;
}
#memberList li div.vote {
  color: #FFF;
  text-shadow: none;
  font-size: 1em;
}
</style>

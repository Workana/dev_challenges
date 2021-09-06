<template>
  <div class="members">
    <ul id="memberList">
      <li :key="member.name" v-for="member in this.members">
        <div class="status">{{member.vote ? '✅' : ''}}</div>
        <div class="name">{{member.name}}</div>
        <div class="vote">{{member.vote ? member.vote : '-'}}</div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "MembersContainer",
  props: {members: Array},
}
</script>

<style scoped>
#memberList {
  list-style: none;
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
  font-size: 1.5em;
}
</style>

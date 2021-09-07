<template>
  <header>
    <h1>♠ Planning Poker ♠</h1>
    <router-link to="/">
      <div id="logo"></div>
    </router-link>
    <h2>Hiring Challenge 👋</h2>
  </header>
</template>

<script>
export default {
  name: "Header"
}
</script>

<style scoped>
#logo {
  margin: auto;
  height: 35px;
  width: 219px;
  background: url(https://wkncdn.com/newx/assets/build/img/workana-logo-2x.9e13d14c2.png) no-repeat;
  background-size: cover;
}
</style>

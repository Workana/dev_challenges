<template>
  <div id="app">
    <Header/>
    <router-view />
  </div>
</template>

<script>

import Header from "./components/molecules/Header";

export default {
  name: 'App',
  components: {Header},
}
</script>

<style>
body {
  box-sizing: border-box;
  font-family: Arial, serif;
  margin: 0;
  background: #fff;
  text-align: center;
}

h1 {
  margin: 0;
  color: #e76f51;
  text-shadow: 2px 2px 2px #ccc;
}
h2 {
  margin: auto;
  color: #e76f51;
  font-size: 1em;
  text-shadow: 1px 1px 2px #ccc;
  text-align: center;
}
h3 {
  color: #132a55;
  text-shadow: 2px 2px 2px #ccc;
}
button {
  background-color: #1c3f7f;
  border: none;
  color: white;
  padding: 12px 30px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 20px 5px;
  transition-duration: 0.2s;
  cursor: pointer;
}

button:hover {
  background-color: #132a55;
}

input{
  font-size: 16px;
  font-family: inherit;
  padding: 12px;
  background-color: #fff;
  border: 2px solid #000000A0;
  border-radius: 4px;
}

.error{
  color: red;
}
</style>

<template>
  <nav>
    <router-link to="/doctors">Doctor Management</router-link> |
    <router-link to="/patients">Patient Management</router-link> |
    <router-link to="/appointments">Appointment Management</router-link> |
    <router-link to="/logout">Logout</router-link>
  </nav>
  <router-view />
  </template>
  
  <script>
  export default {
    name: 'DashBoard'
  }
  </script>
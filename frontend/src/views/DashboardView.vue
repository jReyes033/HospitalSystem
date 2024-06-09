<template>
    <div>
      <nav>
        <router-link to="/doctor">Doctor Management</router-link>
      </nav>
      <router-view/>
    </div>
  </template>
  
  <script>
  export default {
    name: 'DoctorView'
  }
  </script>
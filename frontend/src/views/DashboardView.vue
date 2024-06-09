<template>
  <nav>
    <router-link v-if="isAdmin" to="/doctors">Doctor Management |</router-link>
    <router-link v-if="isAdmin || isDoctor" to="/patients"> Patient Management |</router-link>
    <router-link v-if="isDoctor || isPatient" to="/appointments"> Appointment Management |</router-link>
    <router-link v-if="isDoctor || isPatient" to="/medicalrecords"> Medical Record Management |</router-link>
    <router-link v-if="isAdmin" to="/users"> Admin View |</router-link>
    <router-link to="/logout"> Logout |</router-link>
  </nav>
  <router-view />
</template>

<script>
export default {
  name: 'DashBoard',
  data() {
    return {
      user: null,
    };
  },
  computed: {
    isAdmin() {
      return this.user && this.user.userType === 'admin';
    },
    isDoctor() {
      return this.user && this.user.userType === 'doctor';
    },
    isPatient() {
      return this.user && this.user.userType === 'patient';
    },
  },
  created() {
    this.loadUserFromLocalStorage();
  },
  methods: {
    loadUserFromLocalStorage() {
      const user = localStorage.getItem('user');
      if (user) {
        this.user = JSON.parse(user);
      }
    },
  },
};
</script>
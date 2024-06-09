<template>
    <div class="hello">
        <h1>Doctor Management</h1>
    </div>
</template>

<script>

export default {
    name: 'DoctorManagement',
    data() {
        return {
            doctors: []
        };
    },
    mounted() {
        this.fetchDoctors();
    },
    methods: {
        fetchDoctors() {
            fetch('http://127.0.0.1:8000/api/user', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    this.doctors = data;
                    console.log(this.doctors);
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error.request);
                });
        },
    }
};
</script>

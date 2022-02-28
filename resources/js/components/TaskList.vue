<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- create -->
            <div class="mb-4 p-2 border-2">
                <div class="">
                    <div class="w-full mb-2">
                        <label>name:</label>
                        <input
                            v-model="inputName"
                            type="text" class="w-full border-gray-300 rounded-md" >
                    </div>
                    <div class="mb-2">
                        <label>due date:</label>
                        <input
                            v-model="inputDate"
                            type="text" class="w-full border-gray-300 rounded-md" >
                    </div>
                    <button class="px-2 rounded-lg border"
                         @click="createTask">create</button>
                </div>
            </div>
            <!-- delete and update -->
            <Task
                v-for="item in data"
                :key="item['id']"
                :id="item['id']"
                :name="item['name']"
                :due_date="item['due_date']"
                @refresh="handleRefresh" />

        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            data: [],
            inputName: '',
            inputDate: ''
        }
    },
    created() {
        this.getAllTasks()
    },
    methods: {
        handleRefresh() {
            this.getAllTasks()
        },
        getAllTasks() {
            fetch('http://127.0.0.1/api/tasks')
                .then(response => response.json())
                .then(json => {
                    console.log(json)
                    if(json) {
                        this.data = json
                    }
                }).catch( e => {
                    console.log(e)
            })
        },
        createTask() {
            if( !this.inputName || !this.inputDate) {
                alert("name or due_date cannot be empty")
                return
            }

            const dtFormat = "YYYY-MM-DD HH:mm:ss"
            const dtIsValid = moment(this.inputDate, dtFormat, true).isValid()
            if (!dtIsValid) {
                alert("due_date format error")
                return
            }

            const data = {
                name: this.inputName,
                due_date: this.inputDate
            }

            console.log(data)
            fetch('http://127.0.0.1/api/tasks', {
                body: JSON.stringify(data),
                method: 'POST',
                headers : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if(response.ok) {
                        this.getAllTasks()
                    }
                })
                .catch(e => {
                    console.log(e)
                })

        }
    }
}
</script>

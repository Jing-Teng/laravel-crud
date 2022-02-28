<template>
    <div class="container">
        <!-- download -->
        <div class="my-2 flex justify-content-center">
            <button
                class="bg-green-700 text-white rounded-md px-3 py-1 align-self-center"
                @click="downloadCSVData">download csv</button>
        </div>

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
                    <label>role:</label>
                    <input
                        v-model="inputRole"
                        type="text" class="w-full border-gray-300 rounded-md" >
                </div>
                <button class="px-2 rounded-lg border"
                        @click="createUser">create</button>
            </div>
        </div>

        <!-- delete and update -->
        <User v-for="user in data"
              :key="user['id']"
              :id="user['id']"
              :name="user['name']"
              :role="user['role']"
              @refresh="handleRefresh">
            <Task
                v-for="item in user['tasks']"
                :key="item['id']"
                :id="item['id']"
                :name="item['name']"
                :due_date="item['due_date']"
                @refresh="handleRefresh" />
        </User>
    </div>
</template>

<script>
export default {
    data(){
        return {
            data: [],
            inputName: '',
            inputRole: ''
        }
    },
    created() {
        this.getAllUserTask()
    },
    methods: {
        handleRefresh() {
            this.getAllUserTask()
        },
        getAllUserTask() {
            fetch('http://127.0.0.1/api/user-task')
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
        createUser() {
            if( !this.inputName || !this.inputRole) {
                alert("name or role cannot be empty")
                return
            }

            const data = {
                name: this.inputName,
                role: this.inputRole
            }

            console.log(data)
            fetch('http://127.0.0.1/api/users', {
                body: JSON.stringify(data),
                method: 'POST',
                headers : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if(response.ok) {
                        this.getAllUserTask()
                    }
                })
                .catch(e => {
                    console.log(e)
                })

        },
        downloadCSVData() {
            //Convert JSON Array to string.
            var json = JSON.stringify(this.data);
            var blob = new Blob([json]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "userList.txt";
            link.click();
        }
    }
}
</script>

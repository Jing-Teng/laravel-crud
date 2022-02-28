<template>
    <div class="flex justify-content-center">
        <div class="card w-full">
            <div class="card-header flex justify-content-between">
                <div class="">
                    <div class="mb-2">
                        <div>user name:</div>
                        <div v-if="isUpdating">
                            <input type="text"
                                   v-model="inputName">
                        </div>
                        <div v-if="!isUpdating">
                            {{ inputName }}
                        </div>
                    </div>

                    <div class="">
                        <div>user role:</div>
                        <div v-if="isUpdating">
                            <input type="text"
                                   v-model="inputRole">
                        </div>
                        <div v-else="isUpdating">
                            {{ inputRole }}
                        </div>
                    </div>
                </div>

                <div class="">
                    <div v-if="isUpdating">
                        <button
                            class="px-2 border rounded-lg"
                            @click="handleUpdate">submit</button>
                    </div>
                    <div v-if="!isUpdating">
                        <button @click="isUpdating = true"
                                class="px-2 border rounded-lg">update</button>
                        <button @click="handleDelete"
                                class="px-2 border rounded-lg">delete</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="flex justify-content-end">
                    <button
                        @click="assignTask"
                        class="px-2 mr-2 border rounded-lg">assign task</button>
                    <button
                        @click="removeTask"
                        class="px-2 mr-2 border rounded-lg">remove task</button>
                    id:
                    <input type="text"
                           class="w-20 h-6 px-2 border-gray-300 rounded-md"
                           placeholder="task ID"
                           v-model="taskId">
                </div>

                <div class="mb-2">tasks:</div>
                <slot></slot>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["id", "name", "role"],
    data() {
        return {
            inputName: this.name,
            inputRole: this.role,
            isUpdating: false,
            taskId: 0
        }
    },
    methods: {
        handleUpdate() {
            if( !this.inputName || !this.inputRole ) {
                alert("name or role cannot be empty")
                return
            }

            const data = {}

            if(this.inputName) {
                data.name = this.inputName
            }
            if(this.inputRole) {
                data.role = this.inputRole
            }

            console.log({data})

            fetch(`http://127.0.0.1/api/users/${this.id}`, {
                body: JSON.stringify(data),
                method: 'PUT',
                headers : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
                .then(json => {
                    console.log(json)
                    this.data = json

                    this.$emit('refresh')
                    this.isUpdating = false
                })
                .catch(e => {
                    console.log(e)
                    this.$emit('refresh')
                    this.isUpdating = false
                })

        },
        handleDelete() {
            alert(`user id ${this.id} is deleted`)

            fetch(`http://127.0.0.1/api/users/${this.id}`, {
                method: 'DELETE',
                headers : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
                .then(json => {
                    console.log(json)
                    this.$emit('refresh')
                })
                .catch(e => {
                    this.$emit('refresh')
                    console.log(e)
                })

        },
        assignTask() {

            const data = {
                userId: this.id,
                taskId: this.taskId
            }

            fetch(`http://127.0.0.1/api/user-task`, {
                method: 'POST',
                headers : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(response => {
                if(!response.ok) {
                    throw new Error('assign failed')
                }
                return response.json()
            })
                .then(json => {
                    console.log(json)
                    this.$emit('refresh')
                })
                .catch(e => {
                    alert('assign failed')
                    console.log(e)
                })
        },
        removeTask() {

            const data = {
                userId: this.id,
                taskId: this.taskId
            }

            fetch(`http://127.0.0.1/api/user-task`, {
                method: 'DELETE',
                headers : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(response => {
                if(!response.ok) {
                    throw new Error('remove failed')
                }
                return response.json()
            })
                .then(json => {
                    console.log(json)
                    this.$emit('refresh')
                })
                .catch(e => {
                    console.log(e)
                })
        }
    }
}
</script>

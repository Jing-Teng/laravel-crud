<template>
    <div class="flex justify-content-center">
        <div class="card w-full">
            <div class="card-header flex justify-content-between">
                <div class="">
                    task name:
                    <div class="">
                        <div v-if="isUpdating">
                            <input type="text"
                                   v-model="inputName">
                        </div>
                        <div v-else="isUpdating">
                            {{ inputName }}
                        </div>
                    </div>
                </div>
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
            <div class="card-body">
                due date:
                <div class="">
                    <div v-if="isUpdating">
                        <input type="text"
                               v-model="inputDue_date">
                    </div>
                    <div v-else="isUpdating">
                        {{ inputDue_date }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["id", "name", "due_date"],
        data() {
            return {
                inputName: this.name,
                inputDue_date: this.due_date,
                isUpdating: false
            }
        },
        methods: {
            handleUpdate() {
                if( !this.inputName || !this.inputDue_date ) {
                    alert("name or due_date cannot be empty")
                    return
                }

                // validate time format
                const dtFormat = "YYYY-MM-DD HH:mm:ss"
                const dtIsValid = moment(this.inputDue_date, dtFormat, true).isValid()
                if (!dtIsValid) {
                    alert("due_date format error")
                    return
                }

                const data = {}

                if(this.inputName) {
                    data.name = this.inputName
                }
                if(this.inputDue_date) {
                    data.due_date = this.inputDue_date
                }

                console.log({data})

                fetch(`http://127.0.0.1/api/tasks/${this.id}`, {
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
                alert(`task id ${this.id} is deleted`)

                fetch(`http://127.0.0.1/api/tasks/${this.id}`, {
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

            }
        }
    }
</script>

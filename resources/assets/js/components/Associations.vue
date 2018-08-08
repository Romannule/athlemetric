<template>
    <div>
        <h1>Associations</h1>
        <form action="#" @submit.prevent="edit ? updateAssociation(association.id) : createAssociation()">
            <div class="form-group">
                <label>Name</label>
                <input v-model="association.name" type="text" name="name" class="form-control" placeholder="ex. International Federation of Association Football">
            </div>
            <div class="form-group">
                <label>Code</label>
                <input v-model="association.code" type="text" name="code" class="form-control" placeholder="ex. FIFA, CAF">
            </div>
            <div class="form-group">
                <button v-show="!edit" type="submit" class="btn btn-primary" style="width:100%">Create</button>
                <button v-show="edit" type="submit" class="btn btn-primary" style="width:100%">Update</button>
            </div>
        </form>
        <ul class="list-group">
            <li class="list-group-item" v-for="association in list">
                {{ association.name }} ({{ association.code }})
                <button @click="showAssociation(association.id)" class="btn btn-default btn-xs">Edit</button>
                <button @click="deleteAssociation(association.id)" class="btn btn-danger btn-xs">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                edit: false,
                list: [],
                association: {
                    id: '',
                    name: '',
                    code: ''
                }
            }
        },
        mounted: function() {
            this.fetchAssociationList();
        },
        methods: {
            fetchAssociationList: function() {
                axios.get('api/associations')
                    .then((response) => {
                        console.log(response.data);
                        this.list = response.data;
                    }).catch((error) => {
                        console.log(error);
                    });
            },
            createAssociation: function() {
                let self = this;
                let params = Object.assign({}, self.association);
                axios.post('api/association/store', params)
                    .then(function() {
                        self.association.name = '';
                        self.association.code = '';
                        self.edit = false;
                        self.fetchAssociationList();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            showAssociation: function(id) {
                let self = this;
                axios.get('api/association/' + id)
                    .then(function(response) {
                        self.association.id = response.data.id;
                        self.association.name = response.data.name;
                        self.association.code = response.data.code;
                    })
                    self.edit = true;
            },
            updateAssociation: function(id) {
                let self = this;
                let params = Object.assign({}, self.association);
                axios.patch('api/association/' + id, params)
                    .then(function() {
                        self.association.name = '';
                        self.association.code = '';
                        self.edit = false;
                        self.fetchAssociationList();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            deleteAssociation: function(id) {
                let self = this;
                axios.delete('api/association/' + id)
                    .then(function(response) {
                        self.fetchAssociationList();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
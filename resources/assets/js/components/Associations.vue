<template>
    <div>
        <h1>Associations</h1>
        <button @click="clearAssociation()" class="btn btn-primary" data-toggle="modal" data-target="#association">
            Create
        </button>
        <hr>
        <ul class="list-group">
            <li class="list-group-item" :key="association.id" v-for="association in list">
                <a href="#">{{ association.name }} ({{ association.code }})</a>
                <div class="btn-group pull-right">
                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a @click="showAssociation(association.id)" data-toggle="modal" data-target="#association" href="#">
                                Edit
                            </a>
                        </li>
                        <li>
                            <a @click="deleteAssociation(association.id)" href="#">
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="modal fade" id="association" tabindex="-1" role="dialog" aria-labelledby="associationLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 v-show="!edit" class="modal-title" id="associationLabel">Create Association</h4>
                        <h4 v-show="edit" class="modal-title" id="associationLabel">Edit Association</h4>
                    </div>
                    <div class="modal-body">
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
                                <button v-show="!edit" type="submit" class="btn btn-primary" style="width:100%">Save</button>
                                <button v-show="edit" type="submit" class="btn btn-primary" style="width:100%">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            clearAssociation: function() {
                let self = this;
                self.association.name = '';
                self.association.code = '';
                self.edit = false;
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
                        self.edit = true;
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
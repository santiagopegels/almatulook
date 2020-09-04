<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="icon-settings"></i>
            Árbol de Categorías
            <span class="float-right">
        </span>
        </div>
        <div class="card-body">
            <button @click="addNode">Add Node</button>
            <vue-tree-list
                @click="onClick"
                @change-name="onChangeName"
                @delete-node="onDel"
                @add-node="onAddNode"
                :model="getCategories"
                default-tree-node-name="new node"
                default-leaf-node-name="new leaf"
                v-bind:default-expanded="false"
            >
                <template v-slot:leafNameDisplay="slotProps">
        <span>
          {{ slotProps.model.name }} <span class="muted">#{{ slotProps.model.id }}</span>
        </span>
                </template>
                <span class="icon" slot="addTreeNodeIcon">📂</span>
                <span class="icon" slot="addLeafNodeIcon">＋</span>
                <span class="icon" slot="editNodeIcon">📃</span>
                <span class="icon" slot="delNodeIcon">✂️</span>
                <span class="icon" slot="leafNodeIcon">🍃</span>
                <span class="icon" slot="treeNodeIcon">🌲</span>
            </vue-tree-list>
            <button @click="getNewTree">Get new tree</button>
            <pre>
      {{newTree}}
    </pre>
    </div>
    </div>
</template>

<script>
import { VueTreeList, Tree, TreeNode } from 'vue-tree-list'
import {mapGetters} from 'vuex';

export default{
    components: {
        VueTreeList
    },
    data: function () {
        return {
            model: "categories",
            newTree: {},
            data: new Tree([
                {
                    name: 'Node 1',
                    id: 1,
                    pid: 0,
                    dragDisabled: true,
                    addTreeNodeDisabled: true,
                    addLeafNodeDisabled: true,
                    editNodeDisabled: true,
                    delNodeDisabled: true,
                    children: [
                        {
                            name: 'Node 1-2',
                            id: 2,
                            isLeaf: true,
                            pid: 1
                        }
                    ]
                },
                {
                    name: 'Node 2',
                    id: 3,
                    pid: 0,
                    disabled: true
                },
                {
                    name: 'Node 3',
                    id: 4,
                    pid: 0
                }
            ])
        }
    },
    mounted() {
        this.fetchAll();
    },
    computed: {
        ...mapGetters(["isLoading", "categoriesAll", "selected_category"]),
        hasCategories() {
            return Boolean(this.categoriesAll);
        },
        getCategories() {
            return new Tree(this.categoriesAll);
        },
    },
    methods: {
        async fetchAll() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            }).then(response => {
                console.log('categoires',this.categoriesAll[0])
                this.data2 = [ {
                    "text": "Remeras",
                    "icon": "icon-tag"
                }]
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
        onDel(node) {
            console.log(node)
            node.remove()
        },

        onChangeName(params) {
            console.log(params)
        },

        onAddNode(params) {
            console.log(params)
        },

        onClick(params) {
            console.log(params)
        },

        addNode() {
            var node = new TreeNode({ name: 'new node', isLeaf: false })
            if (!this.data.children) this.data.children = []
            this.data.addChildren(node)
        },

        getNewTree() {
            var vm = this
            function _dfs(oldNode) {
                var newNode = {}

                for (var k in oldNode) {
                    if (k !== 'children' && k !== 'parent') {
                        newNode[k] = oldNode[k]
                    }
                }

                if (oldNode.children && oldNode.children.length > 0) {
                    newNode.children = []
                    for (var i = 0, len = oldNode.children.length; i < len; i++) {
                        newNode.children.push(_dfs(oldNode.children[i]))
                    }
                }
                return newNode
            }

            vm.newTree = _dfs(vm.data)
        }
    }
}
</script>

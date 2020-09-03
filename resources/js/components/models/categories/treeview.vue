<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            <i class="icon-settings"></i>
            Árbol de Categorías
            <span class="float-right">
        </span>
        </div>
        <div class="card-body">
            <v-jstree :data="data" @item-click="itemClick"></v-jstree>
        </div>
    </div>
</template>

<script>
import VJstree from 'vue-jstree'

export default{
    components: {
        VJstree
    },
    data: function () {
        return {
            data: [
                {
                    "text": "Same but with checkboxes",
                    "icon": 'icon-tag',
                    "children": [
                        {
                            "text": "initially selected",
                            "selected": true,
                            "icon": 'icon-tag'
                        },
                        {
                            "text": "custom icon",
                            "icon": "icon-tag"
                        },
                        {
                            "text": "initially open",
                            "icon": "icon-tag",
                            "opened": true,
                            "children": [
                                {
                                    "text": "Another node",
                                    "icon": 'icon-tag'
                                }
                            ]
                        },
                        {
                            "text": "custom icon",
                            "icon": "icon-tag"
                        },
                        {
                            "text": "disabled node",
                            "icon": "icon-tag",
                            "disabled": true
                        }
                    ]
                },
                {
                    "text": "Same but with checkboxes",
                    "opened": false,
                    "icon": 'icon-tag',
                    "children": [
                        {
                            "text": "initially selected",
                            "selected": true,
                            "icon": 'icon-tag'
                        },
                        {
                            "text": "custom icon",
                            "icon": "icon-tag"
                        },
                        {
                            "text": "initially open",
                            "icon": "icon-tag",
                            "opened": true,
                            "children": [
                                {
                                    "text": "Another node",
                                    "icon": 'icon-tag',
                                }
                            ]
                        },
                        {
                            "text": "custom icon",
                            "icon": "icon-tag"
                        },
                        {
                            "text": "disabled node",
                            "icon": "icon-tag",
                            "disabled": true
                        }
                    ]
                },
                {
                    "text": "And wholerow selection",
                    "icon": 'icon-tag'
                }
            ]
        }
    },
    methods: {
        itemClick (node) {
            console.log(node.model.text + ' clicked !')
        }
    }
}
</script>

<template functional>
        <a-sub-menu v-if="props.item.children.length > 0" :key="props.item.id" :title="props.item.name" @click.sync="props.clickEvent">
            <header-menu-item v-for="category in props.item.children" :item="category" :key="category.id">
            </header-menu-item>
        </a-sub-menu>
    <a-menu-item v-else @click.native="props.clickEvent">
        {{ props.item.name }}
    </a-menu-item>
</template>

<script>
export default {
    props: ['item', 'clickEvent'],
}
</script>

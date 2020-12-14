<template>
    <div class="vue-tags">
        <vue-tags-input
            v-model="tag"
            :tags="tags"
            :autocomplete-items="filteredItems"
            :autocomplete-min-length="autocompleteMinLength"
            :placeholder="placeholder"
            @tags-changed="newTags => tags = newTags"
            @before-adding-tag="removePopularTag"
            @before-deleting-tag="addPopularTag"
        />
    </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
import EventBus from '../../EventBus';

export default {
    name: "Tag",
    components: {
        VueTagsInput,
    },
    data() {
        return {
            tag: '',
            tags: [],
            autocompleteItems: [],
            autocompleteMinLength: 2,
            placeholder: 'Enter a new tag or select from the list',
        };
    },
    mounted() {
        let $tags = document.getElementById('tags');
        if ($tags) {
            let tags = $tags.value;
            if (tags) {
                this.tags = JSON.parse(tags);
            } else {
                let $ideaId = document.getElementById('idea_id');
                if ($ideaId) {
                    let ideaId = $ideaId.value;
                    if (ideaId) {
                        axios.get('/get-idea/' + ideaId + '/current-tags').then((res) => {
                            this.tags = res.data;
                        });
                    }
                }
            }
            axios.get('/available-tags').then((res) => {
                this.autocompleteItems = res.data;
            });
        }
        EventBus.$on('addCurrentTag', (id, text) => {
            if (id) {
                this.tags.push({id: id, text: text});
            }
        });
    },
    computed: {
        filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
        autocompleteMinLength() {
            return this.autocompleteMinLength;
        },
        placeholder() {
            return this.placeholder;
        }
    },
    methods: {
        removePopularTag(obj) {
            EventBus.$emit('removePopularTag', this.getCurrentTagId(obj));
            obj.addTag();
        },
        addPopularTag(obj) {
            EventBus.$emit('addPopularTag', this.getCurrentTagId(obj), obj.tag.text);
            obj.deleteTag();
        },
        getCurrentTagId(obj) {
            let currentTag = this.autocompleteItems.find(x => x.text === obj.tag.text);
            return currentTag ? currentTag.id : 0;
        }
    },
};
</script>

<style lang="css">
.vue-tags .vue-tags-input {
    max-width: unset !important;
    margin-bottom: 15px;
}
.vue-tags .vue-tags-input .ti-input {
    border-radius: 4px;
}
.vue-tags .vue-tags-input .ti-new-tag-input {
    font-size: 12px;
    height: auto;
}
</style>

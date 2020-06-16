<template>
    <div class="vue-similar-ideas-tags">
        <vue-tags-input
            v-model="tag"
            :tags="tags"
            :autocomplete-items="autocompleteItems"
            :add-only-from-autocomplete="true"
            :placeholder="placeholder"
            @tags-changed="update"
        />
    </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';

export default {
    name: "SimilarIdea",
    components: {
        VueTagsInput,
    },
    data() {
        return {
            tag: '',
            tags: [],
            autocompleteItems: [],
            autocompleteMinLength: 2,
            placeholder: 'Enter a similar idea or select from the list',
            ideaId: 0,
        };
    },
    watch: {
        'tag': 'initItems',
    },
    methods: {
        update(newTags) {
            this.autocompleteItems = [];
            this.tags = newTags;
        },
        initItems() {
            if (this.tag.length < this.autocompleteMinLength) return;

            let similarIdeaIds = [];
            this.tags.forEach((element) => {
                similarIdeaIds.push(element.id);
            });

            const url = '/search-ideas'
                + '?search_similar_idea=' + this.tag
                + '&similar_idea_id=' + similarIdeaIds.toString()
                + '&idea_id=' + this.ideaId;

            axios.get(url).then((res) => {
                this.autocompleteItems = res.data;
            });
        },
    },
    mounted() {
        let $similarIdeas = document.getElementById('similar_ideas');
        if ($similarIdeas) {
            let similarIdeas = $similarIdeas.value;
            if (similarIdeas) {
                this.tags = JSON.parse(similarIdeas);
            } else {
                let $ideaId = document.getElementById('idea_id');
                if ($ideaId) {
                    this.ideaId = $ideaId.value;
                    if (this.ideaId) {
                        axios.get('/get-idea/' + this.ideaId + '/similar-ideas').then((res) => {
                            this.tags = res.data;
                        });
                    }
                }
            }
        }
    },
    computed: {
        placeholder() {
            return this.placeholder;
        }
    },
};
</script>

<style lang="css">
.vue-similar-ideas-tags .vue-tags-input {
    max-width: unset !important;
    margin-bottom: 15px;
}
.vue-similar-ideas-tags .vue-tags-input .ti-input {
    border-radius: 4px;
}
.vue-similar-ideas-tags .vue-tags-input .ti-new-tag-input {
    font-size: 12px;
    height: auto;
}
</style>

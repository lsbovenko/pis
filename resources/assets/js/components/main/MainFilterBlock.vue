<template>
    <div class="left-sidebar sameblock">
        <section id="departments" class="item">
            <ul>
                <li class="first">
                    Отдел
                    <span class="drop">Сбросить</span>
                </li>
                <li v-for="itemDepartament in filters.departmentsList">
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-1">{{ itemDepartament }}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="competenc" class="item">
            <ul>
                <li class="first">Основная компетенция</li>
                <li v-for="itemCompetenc in filters.coreCompetenciesList">
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-2">{{ itemCompetenc }}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="operational" class="item">
            <ul>
                <li class="first">Операционная цель</li>
                <li v-for="itemOperational in filters.operationalGoalsList">
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-3">{{ itemOperational }}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="strategic" class="item">
            <ul>
                <li class="first">Стратегическая задача</li>
                <li v-for="itemStrategic in filters.strategicObjectivesList">
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-4">{{ itemStrategic }}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="type" class="item">
            <ul>
                <li class="first">Тип</li>
                <li v-for="itemType in filters.typesList">
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-5">{{ itemType }}</span>
                    </label>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        name: "MainFilterBlock",
        props: ['filters']
    }
</script>

<style scoped>

</style>
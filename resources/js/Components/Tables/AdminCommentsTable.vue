<script setup>

import {ButtonType} from "@/Enums/ButtonType";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import RouteButton from "@/Components/Buttons/RouteButton.vue";
import moment from "moment";

const props = defineProps({
    company: {
        default: []
    },
});

</script>

<template>
    <div>
        <div class="admin_table_title_container">
            <div class="admin_table_title">{{ __('comments') }}</div>

            <RouteButton
                :button-type="ButtonType.CREATE"
                :inertia-route="route('admin.comment.create', company.id)"
            />
        </div>

        <div class="admin_table_container">
            <table>
                <thead>
                <tr>
                    <th>{{ __('created_at') }}</th>
                    <th>{{ __('comment') }}</th>
                    <th>{{ __('user') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="comment in company.comments">
                    <td>{{ moment(comment.created_at).format("YYYY-MM-DD") }}</td>
                    <td>{{ comment.comment }}</td>
                    <td>{{ comment.user.first_name }}</td>
                    <td class="action_button_container">
                        <DeleteButton
                            :item="comment.id"
                            :route-name="'admin.comment.destroy'"
                        />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';


const form = useForm({
    nombres:'', rut:'', apellidoP:'', apellidoM:''
});
</script>

<template>
    <Head title="Crear Paciente" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Paciente</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="$event => form.post(route('pacientes.store'))"
                        class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="rut" value="Rut"></InputLabel>
                        <TextInput id="rut" v-model="form.rut" autofocus required
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.rut" class="mt-2"></InputError>
                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Guardar
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

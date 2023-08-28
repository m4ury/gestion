<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';

const rutInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    pacientes: {type:Object}
});

const form = useForm({
    rut:'', nombres:'', apellidoP:'', apellidoM:'', fecha_nacimiento:''
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('pacientes.index', {page:event}));
}

const openModal = (op, rut, nombres, apellidoP, apellidoM, fecha_nacimiento, paciente) => {
    modal.value = true;
    nextTick( () => rutInput.value.focus());
    operation.value = op;
    id.value = paciente;
    if (op == 1) {
        title.value = 'Crear Paciente';
    }
    else{
        title.value = 'Editar Paciente';
        form.rut = rut;
        form.nombres = nombres;
        form.apellidoP = apellidoP;
        form.apellidoM = apellidoM;
    }
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}

const save = () => {
    if (operation.value == 1) {
        form.post(route('pacientes.store'),{
            onSuccess: () => {ok('Paciente creado')}
        });
    }
    else{
        form.put(route('pacientes.update', id.value),{
            onSuccess: () => {ok('Paciente modificado')}
        });
    }
}
const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj, icon:'success'});
}

const deletePaciente = (id, rut) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title: 'Estas seguro de eliminar '+rut+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if(result.isConfirmed) {
            form.delete(route('pacientes.destroy', id),{
                onSuccess: () => {ok('Paciente eliminado')}
            });
        }
    });
}

</script>

<template>
    <Head title="Pacientes" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pacientes</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">RUT</th>
                            <th class="px-2 py-2">NOMBRES</th>
                            <th class="px-2 py-2">APELLIDO PAT.</th>
                            <th class="px-2 py-2">APELLIDO MAT.</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="med, i in pacientes.data" :key="med.id">
                            <td class="border border-gray-400 px-2 py-2">{{ med.rut }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ med.nombres }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ med.apellidoP }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ med.apellidoM }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="openModal(2, med.rut, med.nombres, med.apellidoP, med.apellidoM, med.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="deletePaciente(med.id, med.rut)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <VueTailwindPagination
                :current="pacientes.currentPage" :total="pacientes.total"
                :per-page="pacientes.perPage"
                @page-changed="onPageClick($event)"
                ></VueTailwindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal()">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="rut" value="rut: "></InputLabel>
                <TextInput id="rut" ref="rutInput"
                v-model="form.rut" type="text" class="mt-1 block w-3/4"
                placeholder="rut"></TextInput>
                <InputError :messaje="form.errors.rut" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="nombres" value="nombres: "></InputLabel>
                <TextInput id="nombres" ref="nombresInput"
                v-model="form.nombres" type="text" class="mt-1 block w-3/4"
                placeholder="nombres"></TextInput>
                <InputError :messaje="form.errors.nombres" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="apellidoP" value="apellidoP: "></InputLabel>
                <TextInput id="apellidoP" ref="apellidoPInput"
                v-model="form.apellidoP" type="text" class="mt-1 block w-3/4"
                placeholder="apellidoP"></TextInput>
                <InputError :messaje="form.errors.apellidoP" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="apellidoM" value="apellidoM: "></InputLabel>
                <TextInput id="apellidoM" ref="apellidoMInput"
                v-model="form.apellidoM" type="text" class="mt-1 block w-3/4"
                placeholder="apellidoM"></TextInput>
                <InputError :messaje="form.errors.apellidoM" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <FormKit
                    type="form"
                    submit-label="Guardar"
                    >

                    <FormKit
                        type="date"
                        label="Fecha de nacimiento"
                        name="fecha_nacimiento"
                        placeholder="ingrese fecha"
                        validation="required"
                        :validation-messages="{required:'La fecha de nacimiento es requerida'}"
                    />
                </FormKit>

                <InputError :messaje="form.errors.fecha_nacimiento" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing"
                @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

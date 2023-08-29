<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { nextTick, ref, onMounted } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';

const descripcionInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    medicamentos: {type:Object}
});

const form = useForm({
    descripcion:'', presentacion:'', unidad:'', stock_max:''
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('medicamentos.index', {page:event}));
}

const openModal = (op, descripcion, presentacion, unidad, stock_max, medicamento) => {
    modal.value = true;
    nextTick( () => descripcionInput.value.focus());
    operation.value = op;
    id.value = medicamento;
    if (op == 1) {
        title.value = 'Crear Medicamento';
    }
    else{
        title.value = 'Editar Medicamento';
        form.descripcion = descripcion;
        form.presentacion = presentacion;
        form.unidad = unidad;
        form.stock_max = stock_max;
    }
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}

const save = () => {
    if (operation.value == 1) {
        form.post(route('medicamentos.store'),{
            onSuccess: () => {ok('Medicamento creado')}
        });
    }
    else{
        form.put(route('medicamentos.update', id.value),{
            onSuccess: () => {ok('Medicamento modificado')}
        });
    }
}
const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj, icon:'success'});
}

const deleteMedicamento = (id, descripcion) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title: 'Estas seguro de eliminar '+descripcion+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if(result.isConfirmed) {
            form.delete(route('medicamentos.destroy', id),{
                onSuccess: () => {ok('Medicamento eliminado')}
            });
        }
    });
}
</script>

<template>
    <Head title="Medicamentos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Medicamentos</h2>
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

                <table v-if="medicamentos.data.length > 0" class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">DESCRIPCION</th>
                            <th class="px-2 py-2">PRESENTACION</th>
                            <th class="px-2 py-2">UNIDAD</th>
                            <th class="px-2 py-2">STOCK MAXIMO</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="med, i in medicamentos.data" :key="med.id">
                            <td class="border border-gray-400 px-2 py-2">{{ med.descripcion }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ med.presentacion }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ med.unidad }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ med.stock_max }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="openModal(2, med.descripcion, med.presentacion, med.unidad, med.stock_max, med.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="deleteMedicamento(med.id, med.descripcion)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="bg-white grid v-screen place-items-center">
                    <h2 class="p-3 text-lg font.medium text-hray-900">No hay datos</h2>
                </div>
            </div>
            <div v-if="medicamentos.data.length > 0" class="bg-white grid v-screen place-items-center overflow-x-auto">
                <VueTailwindPagination
                :current="medicamentos.currentPage" :total="medicamentos.total"
                :per-page="medicamentos.perPage"
                @page-changed="onPageClick($event)"
                ></VueTailwindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal()">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ title }}
                </h3>
                <button @click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="staticModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="px-6 py-3">
                <InputLabel for="descripcion" value="Descripcion: "></InputLabel>
                <TextInput id="descripcion" ref="descripcionInput"
                v-model="form.descripcion" type="text" class="mt-1 block w-full"
                placeholder="Descripcion"></TextInput>
                <InputError :messaje="form.errors.descripcion" class="mt-2"></InputError>
            </div>
            <div class="px-6 py-3">
                <InputLabel for="presentacion" value="Presentacion: "></InputLabel>
                <TextInput id="presentacion" ref="presentacionInput"
                v-model="form.presentacion" type="text" class="mt-1 block w-full"
                placeholder="Presentacion"></TextInput>
                <InputError :messaje="form.errors.presentacion" class="mt-2"></InputError>
            </div>
            <div class="px-3 flex flex-row justify-between">
                <div class="w-1/2 px-3 py-3">
                    <InputLabel for="unidad" value="Unidad: "></InputLabel>
                    <TextInput id="unidad" ref="unidadInput"
                    v-model="form.unidad" type="text" class="bg-white mt-1 block w-full"
                    placeholder="Unidad"></TextInput>
                    <InputError :messaje="form.errors.unidad" class="mt-2"></InputError>
                </div>

                <div class="w-1/2 px-3 py-3">
                    <InputLabel for="stock_max" value="Stock Max: "></InputLabel>
                    <TextInput id="stock_max" ref="stock_maxInput"
                    v-model="form.stock_max" type="number"
                               class="bg-white mt-1 block w-full"
                    placeholder="stock maximo"></TextInput>
                    <InputError :messaje="form.errors.stock_max" class="mt-2"></InputError>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <PrimaryButton
                    data-modal-hide="staticModal"
                    type="button"
                    @click="save"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-save mx-1"></i> Guardar
                </PrimaryButton>
                <SecondaryButton
                    data-modal-hide="staticModal"
                    type="button"
                    @click="closeModal"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Cancelar
                </SecondaryButton>
            </div>


<!--            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing"
                @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>-->
        </Modal>
    </AuthenticatedLayout>
</template>

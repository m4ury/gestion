<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import DataTable from 'datatables.net-vue3';
import 'datatables.net-dt/css/jquery.dataTables.css';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css';
import JsZip from 'jszip';
import pdfmake from 'pdfmake/build/pdfmake';
import * as pdfFonts from 'pdfmake/build/vfs_fonts';
import Select from 'datatables.net-select';
pdfmake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfmake.vfs;
window.JSZip = JsZip;
DataTable.use(ButtonsHtml5);
DataTable.use(Select);
import Swal from 'sweetalert2';

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
    //closeModal();
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

const columns1 = ref([]);
const buttons1 = ref([]);

columns1.value = [{data:null, render:function(data, row, meta){
    return (meta.row + 1)
}},
{data:'descripcion'},
{data:'presentacion'},
{data:'unidad'},
{data:'stock_max'},
]

buttons1.value = [
    {
        title:'Medicamentos', extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
    {
        title:'Medicamentos', extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"></i> Pdf',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
    },
]
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
                        <i class="fa-solid fa-plus-circle"></i> Crear
                    </PrimaryButton>
                </div>
            </div>
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="medicamentos" :columns="columns1"
                    class="w-full border border-gray-400"
                    :options="{select:true, responsive:true, autoWith:false, dom:'Bfrtip', buttons:buttons1}">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">DESCRIPCION</th>
                            <th class="px-2 py-2">PRESENTACION</th>
                            <th class="px-2 py-2">UNIDAD</th>
                            <th class="px-2 py-2">STOCK</th>
                        </tr>
                    </thead>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

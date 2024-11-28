import DefaultLayout from "@/Layouts/DefaultLayout"
import { columns } from "./columns"
import { DataTable } from "./data-table"
import { Pegawai } from "./pegawai.model"
import axios from "axios"
import { useEffect, useState } from "react"

async function getData(): Promise<Pegawai[]> {
    let res = await axios.post<Pegawai[]>('/pegawai/datatable')
    let data = res.data

    return data
}

export default function Index() {
    let [pegawais, setPegawais] = useState<Pegawai[]>([])

    useEffect(() => {
        getData().then((datas) => {
            let newPegawais: Pegawai[] = pegawais

            for (let index = 0; index < datas.length; index++) {
                const data = datas[index];

                newPegawais.push(data)
            }

            setPegawais([...newPegawais])
        })
    }, []);

    return (
        <DefaultLayout>
            <div className="container mx-auto py-10">
                <DataTable columns={columns} data={pegawais} />
            </div>
        </DefaultLayout>
    )
}

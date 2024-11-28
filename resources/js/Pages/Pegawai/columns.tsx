import { ColumnDef } from "@tanstack/react-table"
import { Pegawai } from "./pegawai.model"

export const columns: ColumnDef<Pegawai>[] = [
  {
    accessorKey: "nip",
    header: "NIP",
  },
  {
    accessorKey: "nama",
    header: "Nama",
  },
]

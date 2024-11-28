import { ColumnDef } from "@tanstack/react-table"
import { Pegawai } from "./pegawai.model"
import { Button } from "@/Components/ui/button"
import { ArrowUpDown } from "lucide-react"

export const columns: ColumnDef<Pegawai>[] = [
  {
    accessorKey: "nip",
    header: ({ column }) => {
      return (
        <Button
          variant="ghost"
          onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
        >
          NIP
          <ArrowUpDown className="ml-2 h-4 w-4" />
        </Button>
      )
    },
  },
  {
    accessorKey: "nama",
    header: ({ column }) => {
      return (
        <Button
          variant="ghost"
          onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
        >
          Nama
          <ArrowUpDown className="ml-2 h-4 w-4" />
        </Button>
      )
    },
  },
]

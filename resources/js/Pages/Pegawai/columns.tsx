import { ColumnDef } from "@tanstack/react-table"
import { Pegawai } from "../../models/pegawai"
import { Button } from "@/Components/ui/button"
import { ArrowDown, ArrowUp, ArrowUpDown } from "lucide-react"

function sortingState(column: any) {
  if (column.getIsSorted()) {
    if (column.getIsSorted() == 'asc') {
      return <ArrowUp className="ml-2 h-4 w-4" />
    } else {
      return <ArrowDown className="ml-2 h-4 w-4" />
    }
  } else {
    return <ArrowUpDown className="ml-2 h-4 w-4" />
  }
}

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
          {sortingState(column)}
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
          {sortingState(column)}
        </Button>
      )
    },
  },
]

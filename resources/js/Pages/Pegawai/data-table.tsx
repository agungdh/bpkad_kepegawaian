"use client"

import {
  ColumnDef,
  flexRender,
  getCoreRowModel,
  SortingState,
  getSortedRowModel,
  getPaginationRowModel,
  useReactTable,
} from "@tanstack/react-table"

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table"
import { useEffect, useState } from "react"
import { Button } from "@/Components/ui/button"
import { Pegawai } from "@/models/pegawai"
import { PaginationResult } from "@/models/pagination-result"
import axios from "axios"
import { columns } from "./columns"

export function DataTable<TData, TValue>() {
  let [pegawais, setPegawais] = useState<Pegawai[]>([])
  let [sorting, setSorting] = useState<SortingState>([])

  async function getData() {
    let param = {
      sort: sorting?.[0]?.id,
      sort_desc: sorting?.[0]?.desc,
    }

    let res = await axios.post<PaginationResult<Pegawai>>('/pegawai/datatable', param)

    let paginationResult = res.data

    let datas = paginationResult.data

    let newPegawais: Pegawai[] = []

    for (let index = 0; index < datas.length; index++) {
      const data = datas[index];

      newPegawais.push(data)
    }

    setPegawais(newPegawais)
  }

  useEffect(() => {
    getData()
  }, []);

  useEffect(() => {
    getData()
  }, [sorting])

  const table = useReactTable({
    data: pegawais,
    columns,
    onSortingChange: setSorting,
    state: {
      sorting,
    },
    manualSorting: true,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
  })

  return (
    <>
      <div className="rounded-md border">
        <Table>
          <TableHeader>
            {table.getHeaderGroups().map((headerGroup) => (
              <TableRow key={headerGroup.id}>
                {headerGroup.headers.map((header) => {
                  return (
                    <TableHead key={header.id}>
                      {header.isPlaceholder
                        ? null
                        : flexRender(
                          header.column.columnDef.header,
                          header.getContext()
                        )}
                    </TableHead>
                  )
                })}
              </TableRow>
            ))}
          </TableHeader>
          <TableBody>
            {table.getRowModel().rows?.length ? (
              table.getRowModel().rows.map((row) => (
                <TableRow
                  key={row.id}
                  data-state={row.getIsSelected() && "selected"}
                >
                  {row.getVisibleCells().map((cell) => (
                    <TableCell key={cell.id}>
                      {flexRender(cell.column.columnDef.cell, cell.getContext())}
                    </TableCell>
                  ))}
                </TableRow>
              ))
            ) : (
              <TableRow>
                <TableCell colSpan={columns.length} className="h-24 text-center">
                  No results.
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </div>
      <div className="flex items-center justify-end space-x-2 py-4">
        <Button
          variant="outline"
          size="sm"
          onClick={() => table.previousPage()}
          disabled={!table.getCanPreviousPage()}
        >
          Previous
        </Button>
        <Button
          variant="outline"
          size="sm"
          onClick={() => table.nextPage()}
          disabled={!table.getCanNextPage()}
        >
          Next
        </Button>
      </div>
    </>
  )
}

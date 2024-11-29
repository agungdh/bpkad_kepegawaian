import { Honorer } from "./honorer";
import { Pegawai } from "./pegawai";

export interface User {
    id:                string;
    username:          string;
    email:             string;
    email_verified_at: Date;
    role:              string;
    created_at:        Date;
    updated_at:        Date;
    pegawai?:           Pegawai;
    honorer?:           Honorer;
    profile:           Pegawai | Honorer;
}
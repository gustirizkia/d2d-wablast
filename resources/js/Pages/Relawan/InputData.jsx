import LRelawan from "@/Layouts/LRelawan";
import { Head, router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import { useGeolocated } from "react-geolocated";
import Swal from "sweetalert2";

export default function InputData() {
    const [Alamat, SetAlamat] = useState(null);
    const [Nama, SetNama] = useState(null);

    const [Latitude, SetLatitude] = useState(null);
    const [Longitude, Setlongitude] = useState(null);

    const { coords, isGeolocationAvailable, isGeolocationEnabled } =
        useGeolocated({
            positionOptions: {
                enableHighAccuracy: true,
            },
        });

    useEffect(() => {
        SetLatitude(coords?.latitude);
        Setlongitude(coords?.longitude);
    }, [coords]);

    const handleSubmit = () => {
        if (!isGeolocationAvailable) {
            Swal.fire({
                icon: "info",
                title: "Kami membutuhkan lokasi anda",
                text: "Aktifkan di pojok atas kiri tanda seru",
            });
        } else {
            let formData = {
                nama: Nama,
                alamat: Alamat,
                latitude: Latitude,
                longitude: Longitude,
            };

            if (!Nama || !Alamat) {
                Swal.fire({
                    icon: "info",
                    text: "Isi form data dengan lengkap",
                });
            }

            router.post("/addRelawan", formData);
        }
    };
    return (
        <LRelawan>
            <Head title="Home" />

            <div className="min-h-screen  flex justify-center flex-col items-center px-3">
                <label className="block w-full">
                    <span className="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                        Nama
                    </span>
                    <input
                        type="text"
                        name="nama"
                        className="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                        placeholder="masukan nama"
                        onChange={(e) => SetNama(e.target.value)}
                    />
                </label>
                <label className="block w-full mt-6">
                    <span className="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                        Alamat
                    </span>
                    <input
                        type="text"
                        name="nik"
                        onChange={(e) => SetAlamat(e.target.value)}
                        className="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                        placeholder="masukan nama"
                    />
                </label>
                <div className=" text-center w-full mt-3">
                    <div
                        className="mt-4 bg-yellow-500 text-center py-2  px-10 rounded-lg text-white w-full"
                        onClick={handleSubmit}
                    >
                        Mulai
                    </div>
                </div>
            </div>
        </LRelawan>
    );
}

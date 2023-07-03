import { Head, router, useForm } from "@inertiajs/react";
import { useEffect, useState } from "react";
import { useGeolocated } from "react-geolocated";
import Swal from "sweetalert2";
import Layout from "../Layouts/User";

export default function Survey({ data_soal, session }) {
    const { data, setData, post, processing, errors } = useForm({
        nama: null,
        alamat: null,
    });
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
        console.log("coords", coords);
    }, [coords]);

    const [AllowLocation, SetAllowLocation] = useState(false);

    useEffect(() => {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                SetAllowLocation(true);
            },
            (err) => {
                Swal.fire({
                    icon: "info",
                    title: "Kami membutuhkan lokasi anda",
                    text: "Aktifkan di pojok atas kiri tanda seru",
                });
                SetAllowLocation(false);
            }
        );

        navigator.permissions.query({ name: "geolocation" }).then((ress) => {
            if (ress.state === "denied") {
                // report(result.state);
                SetAllowLocation(false);
            }
        });
    }, []);

    const [isModalOpen, setIsModalOpen] = useState(false);
    const showModal = () => {
        setIsModalOpen(true);
    };
    const handleOk = () => {
        setIsModalOpen(false);
    };
    const handleCancel = () => {
        setIsModalOpen(false);
    };

    const handleSubmit = () => {
        if (!AllowLocation) {
            Swal.fire({
                icon: "info",
                title: "Kami membutuhkan lokasi anda",
                text: "Aktifkan di pojok atas kiri tanda seru",
            });
        } else if (!data.nama || !data.alamat) {
            Swal.fire({
                icon: "info",
                title: "Data tidak lengkap",
            });
        } else {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    SetAllowLocation(true);
                    console.log("data", data);
                },
                (err) => {
                    Swal.fire({
                        icon: "info",
                        title: "Kami membutuhkan lokasi anda",
                        text: "Aktifkan di pojok atas kiri tanda seru",
                    });
                    SetAllowLocation(false);
                }
            );
            let formData = data;
            formData.latitude = Latitude;
            formData.longitude = Longitude;
            // post("inputDataTarget");
            console.log("formData", formData);
            router.post("/inputDataTarget", formData);
        }
    };

    return (
        <Layout>
            <Head title="Survey" />

            <div className="min-h-screen  flex justify-center flex-col items-center px-3">
                {session.success && (
                    <div className="bg-green-100 w-full rounded-lg px-2 text-sm mb-4">
                        <div className="font-medium w-full py-2  block">
                            Berhasil simpan data
                        </div>
                    </div>
                )}
                <label className="block w-full">
                    <span className="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                        Nama
                    </span>
                    <input
                        type="text"
                        name="nama"
                        onChange={(e) => setData("nama", e.target.value)}
                        className="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                        placeholder="masukan nama"
                    />
                </label>
                <label className="block w-full mt-6">
                    <span className="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                        Alamat
                    </span>
                    <input
                        type="text"
                        name="nik"
                        onChange={(e) => setData("alamat", e.target.value)}
                        className="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                        placeholder="masukan nama"
                    />
                </label>
                <div className=" text-center w-full mt-3">
                    {/* <div className="text-xl font-medium">Mulai Survey</div>
                    <div className="text-gray-700 text-sm">
                        Siapkan Koneksi dan tempat yang nyaman sebelum melakukan
                        penginputan survey ini
                    </div> */}
                    <div
                        className="mt-4 bg-green-600 text-center py-2  px-10 rounded-lg text-white w-full"
                        onClick={handleSubmit}
                    >
                        Mulai
                    </div>
                </div>
            </div>
        </Layout>
    );
}

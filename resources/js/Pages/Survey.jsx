import React, { useEffect, useState } from "react";
import Layout from "../Layouts/User";
import { Head, router, useForm } from "@inertiajs/react";
import { Modal } from "antd";
import Swal from "sweetalert2";

export default function Survey({ data_soal, session }) {
    const { data, setData, post, processing, errors } = useForm({
        nama: null,
        alamat: null,
        latitude: null,
        longitude: null,
    });

    const [AllowLocation, SetAllowLocation] = useState(false);

    useEffect(() => {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                // console.log("position latitude", position.coords.latitude);
                // console.log("position longitude", position.coords.longitude);
                setData("longitude", position.coords.longitude);
                setData("latitude", position.coords.latitude);
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
            console.log("ress", ress);
            if (ress.state === "denied") {
                // report(result.state);
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
        console.log("data", data);
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
            post("inputDataTarget");
        }
    };

    return (
        <Layout>
            <Head title="Survey" />
            <Modal
                title="Info"
                open={isModalOpen}
                onOk={handleOk}
                onCancel={handleCancel}
                footer={[
                    <div
                        className="bg-green-600 inline-block px-3 py-1 rounded-lg text-white"
                        onClick={handleCancel}
                    >
                        Ok
                    </div>,
                ]}
            >
                <div className="text-base">Data tidak lengkap</div>
            </Modal>
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

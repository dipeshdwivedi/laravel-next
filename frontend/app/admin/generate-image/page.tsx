'use client';

import { useState } from 'react';
import callApi from "@/lib/api";
import {UPLOAD_IMAGE} from "@/lib/constant";
import toast from "react-hot-toast";
import {useRouter} from "next/navigation";
import Link from "next/link";

export default function GenerateImage() {
  const [selectedFile, setSelectedFile] = useState<File | null>(null);
  const router =  useRouter();
  const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
    const file = event.target.files?.[0];
    if (file) {
      setSelectedFile(file);
      const reader = new FileReader();
      reader.onload = (): void => {
        const preview = document.querySelector<HTMLDivElement>('#cover-photo-preview');
        if (preview) {
          preview.style.backgroundImage = `url(${reader.result as string})`;
        }
      };
      reader.readAsDataURL(file);
    }
  };

  const handleUpload = async () => {
    if (!selectedFile) {
      toast.error("No Image Selected");
      return;
    }

    const formData = new FormData();
    formData.append('image', selectedFile);

    try {
      const response = await callApi(UPLOAD_IMAGE, "POST", formData);
      // errors property come only in case of error
      if (response.data) {
        toast.success("Image uploaded successfully, generating image variations");
        router.push('/admin/dashboard');
      }
    } catch (error) {
      console.error('Error uploading file:', error);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="w-full max-w-4xl p-12 bg-white rounded-2xl shadow-2xl shadow-gray-500/20">
        <div className="space-y-12">
          <div className="border-b border-gray-900/10 pb-12">
            <div className="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div className="col-span-full">
                <div className="grid grid-cols-2 mt-2 items-center gap-x-3">
                  <div className="relative flex items-center justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-24">
                    Click to select an Image
                    <input
                      type="file"
                      id="cover-photo"
                      name="cover-photo"
                      onChange={handleFileChange}
                      className="z-20 absolute inset-0 rounded-lg mx-auto w-full h-full opacity-0 cursor-pointer"
                    />
                  </div>
                  <div
                    id="cover-photo-preview"
                    className="z-20 h-full w-full bg-contain bg-center bg-no-repeat border border-gray-900/10 rounded-lg"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div className="mt-6 flex items-center justify-end gap-x-6">
          <Link href="/admin/dashboard" type="button" className="text-sm font-semibold leading-6 text-gray-900">
            Cancel
          </Link>
          <button
            type="button"
            onClick={handleUpload}
            className="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  );
}

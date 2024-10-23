'use client';

import React, { useEffect, useState } from "react";
import Link from "next/link";
import callApi from "@/lib/api";
import {GET_IMAGE_VARIANTS, GET_IMAGES} from "@/lib/constant";
import Modal from "@/app/components/Modal";

interface ImageVariantInterface {
  id: string;
  image_id: string;
  url: string;
}

const Dashboard = () => {
  const [images, setImages] = useState<ImageVariantInterface[]|[]>([]);
  const [isOpen, setIsOpen] = useState(false);
  const [selectedImage, setSelectedImage] = useState('');
  const [imageVariants, setImageVariants] = useState([]);

  useEffect(() => {
    const fetchImages = async () => {
      try {
        const response = await callApi(GET_IMAGES, "GET");
        setImages(response.data);
      } catch (error) {
        console.error('Error fetching images:', error);
      }
    };

    fetchImages();
  }, []);
  useEffect(() => {
    const fetchImageVariants = async () => {
      if(selectedImage) {
        try {
          const response = await callApi(GET_IMAGE_VARIANTS(selectedImage), "GET");
          setImageVariants(response.data.variations);
        } catch (error) {
          console.error('Error fetching images:', error);
        }
      }
    };

    fetchImageVariants();
  }, [selectedImage]);

  const handleOpenModal = (image:ImageVariantInterface) => {
    setSelectedImage(image.id);
    setIsOpen(true);
  };

  const handleCloseModal = () => {
    setIsOpen(false);
    setSelectedImage('');
  };

  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-10 max-w-7xl mx-auto">
      <div className="bg-white rounded-lg shadow-lg p-4">
        <div className="flex flex-col items-center justify-center h-full">
          <Link
            href="/admin/generate-image"
            className="mt-4 px-4 py-2 bg-blue-500 rounded-lg text-white"
            title="Add Image"
          >
            +
          </Link>
        </div>
      </div>
      {images.map((image, i) => (
        <div key={i} className="bg-white rounded-lg shadow-lg p-4">
          <div className="flex flex-col items-center relative">
            <div
              className="h-48 w-full bg-cover bg-center rounded-t-lg"
              style={{ backgroundImage: `url(${image.url})` }}
            />
            <button className="absolute top-4 right-4 bg-blue-500/70 text-white px-2 py-1 rounded" onClick={() => handleOpenModal(image)}>View Variants</button>
          </div>
        </div>
      ))}
      {isOpen && (
        <Modal
          open={isOpen}
          onClose={handleCloseModal}
          title="Image Variants"
        >
          <div className="">
            <div className="flex flex-col items-center">
              {imageVariants.length ? imageVariants.map((variant:ImageVariantInterface, i) => (
                  <div
                    key={i}
                    className="h-48 w-full bg-cover bg-center rounded-t-lg m-3"
                    style={{backgroundImage: `url(${variant.url})`}}
                  />
                ))
                : ''}
            </div>
          </div>
        </Modal>
      )}
    </div>
  );
}

export default Dashboard;

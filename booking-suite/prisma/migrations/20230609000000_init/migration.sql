-- Initial migration
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE "User" (
  "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  "email" TEXT NOT NULL UNIQUE
);

CREATE TABLE "Service" (
  "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  "name" TEXT NOT NULL,
  "duration" INTEGER NOT NULL,
  "price" INTEGER NOT NULL
);

CREATE TABLE "Booking" (
  "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  "userId" UUID REFERENCES "User"("id"),
  "serviceId" UUID NOT NULL REFERENCES "Service"("id"),
  "start" TIMESTAMP NOT NULL,
  "end" TIMESTAMP NOT NULL,
  "status" TEXT NOT NULL DEFAULT 'PENDING'
);

CREATE TABLE "Payment" (
  "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  "bookingId" UUID NOT NULL REFERENCES "Booking"("id"),
  "status" TEXT NOT NULL
);

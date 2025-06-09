import { z } from 'zod';
import { prisma } from '../db';
import { initTRPC } from '@trpc/server';

const t = initTRPC.create();

export const bookingRouter = t.router({
  create: t.procedure
    .input(z.object({ serviceId: z.string(), start: z.date(), end: z.date() }))
    .mutation(async ({ input }) => {
      // simplified create booking
      const booking = await prisma.booking.create({ data: input });
      return booking;
    }),
});

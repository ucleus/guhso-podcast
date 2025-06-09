import { prisma } from '../db';
import { initTRPC } from '@trpc/server';

const t = initTRPC.create();

export const dashboardRouter = t.router({
  stats: t.procedure.query(async () => {
    const count = await prisma.booking.count();
    return { count };
  }),
});

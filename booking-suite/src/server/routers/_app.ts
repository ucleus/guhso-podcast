import { initTRPC } from '@trpc/server';
import superjson from 'superjson';
import { bookingRouter } from './booking';
import { serviceRouter } from './service';
import { dashboardRouter } from './dashboard';

const t = initTRPC.create({ transformer: superjson });

export const router = t.router({
  booking: bookingRouter,
  service: serviceRouter,
  dashboard: dashboardRouter,
});

export type AppRouter = typeof router;

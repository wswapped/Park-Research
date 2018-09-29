import cProfile as cp
pr = cp.Profile()
pr.enable()
print("Hello world")
pr.disable()
pr.print_stats(sort='time')